import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { RouterModule, Router, Routes } from '@angular/router';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { HttpModule } from '@angular/http';
import { NgxSmartModalModule, NgxSmartModalService } from 'ngx-smart-modal';

import { DashboardComponent } from './dashboard/dashboard.component';
import { adminRouting } from './admin.routing';
import { MenuComponent } from './menu/menu.component';
import { AjoutMenuComponent } from './menu/ajout/ajout.component';
import { DeleteMenuComponent } from './menu/delete/delete.component';
import { UtilisateurComponent } from './utilisateur/utilisateur.component';
import { AjoutUtilisateurComponent } from './utilisateur/ajout/ajout.component';
import { EntreeComponent } from './entree/entree.component';
import { AjoutEntreeComponent } from './entree/ajout/ajout.component';
import { DeleteEntreeComponent } from './entree/delete/delete.component';
import { PlatComponent } from './plat/plat.component';
import { AjoutPlatComponent } from './plat/ajout/ajout.component';
import { DeletePlatComponent } from './plat/delete/delete.component';
import { DessertComponent } from './dessert/dessert.component';
import { AjoutDessertComponent } from './dessert/ajout/ajout.component';
import { DeleteDessertComponent } from './dessert/delete/delete.component';
import { BoissonComponent } from './boisson/boisson.component';
import { AjoutBoissonComponent } from './boisson/ajout/ajout.component';
import { DeleteBoissonComponent } from './boisson/delete/delete.component';
import { MenuListComponent } from './menu-list/menu-list.component';
import { MenuAddComponent } from './menu-add/menu-add.component';


@NgModule({
  imports: [
    CommonModule,
    adminRouting,
    FormsModule,
    HttpModule,
    NgxSmartModalModule.forRoot(),
    // AlertComponent
  ],
  declarations: [
    DashboardComponent,
    MenuComponent,
    AjoutMenuComponent,
    DeleteMenuComponent,
    UtilisateurComponent,
    AjoutUtilisateurComponent,
    EntreeComponent,
    AjoutEntreeComponent,
    DeleteEntreeComponent,
    PlatComponent,
    AjoutPlatComponent,
    DeletePlatComponent,
    DessertComponent,
    AjoutDessertComponent,
    DeleteDessertComponent,
    BoissonComponent,
    AjoutBoissonComponent,
    DeleteBoissonComponent,
    MenuListComponent,
    MenuAddComponent,
    // RegisterComponent,
    // LoginComponent
  ],
  providers: [
    HttpClientModule,
    NgxSmartModalService
  ]
})
export class AdminModule { }
