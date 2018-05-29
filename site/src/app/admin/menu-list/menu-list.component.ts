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
  noList: boolean;
  tobeDelete: object;

  constructor(private http: Http, private route: ActivatedRoute, private router: Router, public ngxSmartModalService: NgxSmartModalService) { }

  ngOnInit() {
    this.menuCharger = true;
    this.menuContainerTitle = this.route.snapshot.params.menuTitle;
    this.menuContainerId = this.route.snapshot.params.menuId;

    let url = urlApi + '/getlist/' + this.menuContainerTitle + '/' + this.menuContainerId;

    this.http.get(url).subscribe((response) => {
      this.menuList = response.json();
      if (!this.menuList){
        this.listValid = true;
        this.noList = true;
      }
      this.menuCharger = false;
    });
  }

  modifierMenu(data){
    this.modif = data;
  }

  supprimerPrepare(data){
    this.tobeDelete = data;
  }

  supprimerMenu(values){
    this.listValid = false;
    let url = urlApi + '/delete/' + this.menuContainerId + '/' + values.id;
    console.log(url);

    this.http.post(url, values).subscribe((response) => {
      this.deleted = (response) ? true : false;
      this.ngxSmartModalService.closeLatestModal();
      this.listValid = true;
      this.ngOnInit();
    });
  }

  onClickSubmit(values){
    this.listValid = false;
    this.menuCharger = true;
    let url = urlApi + '/updateList/' + this.menuContainerId + '/' + values.id;

    this.http.post(url, values).subscribe((response) => {
      this.modified = (response) ? true : false;
      this.ngxSmartModalService.closeLatestModal();
      this.listValid = true;
      this.menuCharger = false;
      this.ngOnInit();
    });
  }

}
