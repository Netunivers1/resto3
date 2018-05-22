import { Component, OnInit } from '@angular/core';
import { Http } from '@angular/http';
import { urlApi } from '../../config/host';

@Component({
  selector: 'app-desserts',
  templateUrl: './desserts.component.html',
  styleUrls: ['./desserts.component.css']
})
export class DessertsComponent implements OnInit {

  menus;
  menusCharger = false;

  constructor(
    private http: Http
  ) { }

  ngOnInit() {
    let url = urlApi + '/dessert';
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
