import { Component, OnInit } from '@angular/core';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { ActivatedRoute, Router } from '@angular/router';
import { urlApi } from '../../config/host';
import { Observable } from 'rxjs/Observable';
import { NgxSmartModalService } from 'ngx-smart-modal';

@Component({
  selector: 'app-menu-container',
  templateUrl: './menu-container.component.html',
  styleUrls: ['./menu-container.component.css']
})
export class MenuContainerComponent implements OnInit {
  menuContainer: Array<any>;

  constructor( private http: Http, private route: ActivatedRoute, private router: Router, public ngxSmartModalService: NgxSmartModalService ) {
  }
  
  ngOnInit() {
    let url = urlApi + '/getmenu';
    this.http.get(url).subscribe( (response: Response) => {
      this.menuContainer = response.json();
          console.log(this.menuContainer);
        }
      );
  }
}
