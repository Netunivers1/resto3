import { Component, OnInit } from '@angular/core';
import { Http } from '@angular/http';
import 'rxjs/add/operator/map';
import { FormGroup, FormControl, Validators} from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { urlApi } from '../../../config/host';

@Component({
  selector: 'app-ajout',
  templateUrl: './ajout.component.html',
  styleUrls: ['./ajout.component.css']
})
export class AjoutEntreeComponent implements OnInit {

	constructor(
		private http: Http,
		private router: Router
		) { }

	ngOnInit() {
	}

	onClickSubmit(data) {
		let messageErreur = this.validationFomulaire(data);
		if ( messageErreur ) {
			alert(messageErreur);
			return false;
		}
		let url = urlApi + '/entree';
		this.http.post(
			url,
			data
		).subscribe(
			res => {
				this.router.navigate(['/admin/entree/insert']);
			},
			err => {
				console.log(err);
				alert('L\'entrée ' + data.nom + ' existe déjà');
			}
		);      
	}

	validationFomulaire(data) {
		let message = '';
		if ( data.nom === '' ) message = 'Le champ Nom ne doit pas être vide';
		if ( data.prix === '' ) message = 'Le champ Prix ne doit pas être vide';
		if ( data.ingredient === '' ) message = 'Le champ Ingrédient ne doit pas être vide';

		if ( message != '' ) return message;

		return false; 
	}

}
