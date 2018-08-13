import { Component, OnInit } from '@angular/core';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { ActivatedRoute, Router } from '@angular/router';
import { urlApi } from '../../config/host';
import { Observable } from 'rxjs/Observable';
import { NgxSmartModalService } from 'ngx-smart-modal';

@Component({
  selector: 'app-menu-list',
  templateUrl: './menu-list.component.html',
  styleUrls: ['./menu-list.component.css']
})
export class MenuListComponent implements OnInit {

  menuList: object[];
  menuContainerTitle: string;
  menuContainerId: number;
  modif: object;
  modified: boolean;
  deleted: boolean;
  listValid = true;
  menuCharger: boolean;
  paginate_show:boolean = false;
  paginate:Array<number>;
  page_current:number = 0;
  p_prev:number;
  p_next:number;
  max_page:number = 2;
  limits:number = 5;

  constructor(private http: Http, private route: ActivatedRoute, private router: Router, public ngxSmartModalService: NgxSmartModalService) { }

  ngOnInit() {
    this.menuContainerTitle = this.route.snapshot.params.menuTitle;
    this.menuContainerId = this.route.snapshot.params.menuId;

    this.pagination(1);
  }

  /**
   * Pagination request
   *
   * @param page offset from where to show
   *
   * @return void
  */
  pagination(page_param:number, limits:number = 0) {
    let is_paginate_allowed:boolean = true;

    if (page_param == this.page_current && limits == 0)
      is_paginate_allowed = false;

    if(limits == 0)
      limits = this.limits;
    else
      this.limits = limits;

    // check if paginate is allowed
    if (page_param == 0)
      is_paginate_allowed = false;

    if(is_paginate_allowed) {
      this.menuCharger = true;
      let url = urlApi + '/getlist/' + this.menuContainerTitle + '/' + this.menuContainerId + "/1";
      this.http.get(url + "/" + page_param + "/" + limits)
      .map(
        (response) => response.json()
      )
      .subscribe(
        (data) => {
          this.menuList = data.contain || [{ nom: "---", gm: "---", pm: "---"}];
          this.menuCharger = false;
          this.p_prev = data.p_prev;
          this.p_next = data.p_next;
          this.page_current = data.p_current;

          this.paginate_show = (data.count > this.limits);

          let page = [];
          let max = Math.ceil(data.count / limits);
          for (var i = 1; i <= max; ++i) {
            page.push(i);
          }

          this.max_page = page.length;
          this.paginate = page;

          if(page_param == 1)
            this.p_prev = 0;
          if(this.p_next > this.max_page)
            this.p_next = 0;
        }
      )    
    }
  }

  modifierMenu(data){
    this.modif = data;
  }

  initializingDelete(values) {
    this.modif = values;
  }

  supprimerMenu(values = null){
    this.ngxSmartModalService.closeLatestModal();
    if (values == null) {
      values = this.modif;
    }
    this.listValid = false;
    let url = urlApi + '/delete/' + this.menuContainerId + '/' + values.id;
    console.log(url);

    this.http.post(url, values).subscribe((response) => {
      this.deleted = (response) ? true : false;
      this.listValid = true;
      this.pagination(this.page_current, this.limits);
    });
  }

  onClickSubmit(values){
    this.ngxSmartModalService.closeLatestModal();
    this.listValid = false;
    this.menuCharger = true;
    let url = urlApi + '/updateList/' + this.menuContainerId + '/' + values.id;

    this.http.post(url, values).subscribe((response) => {
        this.modified = (response) ? true : false;
        this.listValid = true;
        this.menuCharger = false;
        this.pagination(this.page_current, this.limits);
    });
  }
}
