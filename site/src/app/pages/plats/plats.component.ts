import { Component, OnInit } from '@angular/core';
import { Http } from '@angular/http';
import { urlApi } from '../../config/host';

@Component({
  selector: 'app-plats',
  templateUrl: './plats.component.html',
  styleUrls: ['./plats.component.css']
})
export class PlatsComponent implements OnInit {

  menus;
  menusCharger = false;

  constructor(
    private http: Http
  ) { }

  ngOnInit() {
    let url = urlApi + '/plat';
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
