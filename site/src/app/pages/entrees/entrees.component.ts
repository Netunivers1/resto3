import { Component, OnInit } from '@angular/core';
import { Http } from '@angular/http';
import { urlApi } from '../../config/host';

@Component({
  selector: 'app-entrees',
  templateUrl: './entrees.component.html',
  styleUrls: ['./entrees.component.css']
})
export class EntreesComponent implements OnInit {

  menus;
  menusCharger = false;

  constructor(
    private http: Http
  ) { }

  ngOnInit() {
    let url = urlApi + '/entree';
    this.http.get(url)
      .map(
        (response) => response.json()
      )
      .subscribe(
        (data) => {
          this.menus = data;
          this.menusCharger = (data.length > 0) ? true : false;
        }
      );
  }
}
