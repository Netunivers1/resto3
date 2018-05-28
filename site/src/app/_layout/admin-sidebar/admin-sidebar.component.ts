import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
// import { MenuContainerComponent } from '../../admin/menu-container/menu-container.component';

@Component({
	// tslint:disable-next-line:component-selector
	selector: 'admin-sidebar',
	templateUrl: './admin-sidebar.component.html',
	styleUrls: ['./admin-sidebar.component.css']
})
export class AdminSidebarComponent implements OnInit {

	constructor(
		private router: Router,
	) { }

	ngOnInit() {
	}
	deconnexion() {
        localStorage.removeItem('infosUtilisateur');
        this.router.navigate(['/']);
	}

}
