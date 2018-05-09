import { Component, OnInit } from '@angular/core';
import { Http } from '@angular/http';
import { urlApi } from '../../config/host';

@Component({
  selector: 'app-nosPresentation',
  templateUrl: './nos_presentation.component.html',
  styleUrls: ['./nos_presentation.component.css']
})
export class NosPresentationComponent implements OnInit {

	plats;
	platsCharger = false;

	constructor(
		private http: Http
	) { }

	ngOnInit() {		
	}

}
