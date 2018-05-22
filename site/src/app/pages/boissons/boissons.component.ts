import { Component, OnInit } from '@angular/core';
import { Http } from '@angular/http';
import { urlApi } from '../../config/host';

@Component({
  selector: 'app-boissons',
  templateUrl: './boissons.component.html',
  styleUrls: ['./boissons.component.css']
})
export class BoissonsComponent implements OnInit {

  menus;
  menusCharger = false;

  constructor(
    private http: Http
  ) { }

  ngOnInit() {
    let url = urlApi + '/boisson';
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
