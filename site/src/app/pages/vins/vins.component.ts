import { Component, OnInit } from '@angular/core';
import { Http } from '@angular/http';
import { urlApi } from '../../config/host';

@Component({
  selector: 'app-vins',
  templateUrl: './vins.component.html',
  styleUrls: ['./vins.component.css']
})
export class VinsComponent implements OnInit {

  menus: object[];
  menusCharger: boolean;

  constructor(private http: Http) { }

  ngOnInit() {
    let url = urlApi + '/getlist/vins/1/0';
    this.http.get(url).subscribe(
        (data) => {
          this.menus = data.json().contain;
          this.menusCharger = (this.menus) ? true : false;
        }
      );
  }

}
