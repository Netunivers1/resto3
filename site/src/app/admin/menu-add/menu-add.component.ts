import { Component, OnInit } from '@angular/core';
import { Http } from '@angular/http';
import 'rxjs/add/operator/map';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { urlApi } from '../../config/host';

@Component({
  selector: 'app-menu-add',
  templateUrl: './menu-add.component.html',
  styleUrls: ['./menu-add.component.css']
})
export class MenuAddComponent implements OnInit {

  menuContainerTitle: string;
  menuContainerId: number;

  constructor(private http: Http, private route: ActivatedRoute, private router: Router) { }

  ngOnInit() {
    this.menuContainerTitle = this.route.snapshot.params.menuTitle;
    this.menuContainerId = this.route.snapshot.params.menuId;
  }

  onClickSubmit(data) {
    // console.log(this.menuContainerId, this.menuContainerTitle);

    let url = urlApi + '/add/' + this.menuContainerTitle + '/' + this.menuContainerId;

    this.http.post(url, data).subscribe((response) => {
      console.log(response);
      this.router.navigate(['/admin/vins/1']);
    });

    // console.log(data);
  }
}
