import { Routes, RouterModule, Route } from '@angular/router';
import { DashboardComponent } from './dashboard/dashboard.component';
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


const routes: Routes = [
    // dashboard
    { path: '', redirectTo: 'dashboard', pathMatch: 'full' },
    { path: 'dashboard', component: DashboardComponent },

    // Menu
    { path: 'ajoutmenu', component: AjoutMenuComponent },
    { path: 'deletemenu/:id', component: DeleteMenuComponent },
    { path: 'menu/:insertOrList', component: MenuComponent },

    // Utilisateur
    { path: 'utilisateur', component: UtilisateurComponent },
    { path: 'ajoututilisateur', component: AjoutUtilisateurComponent },

    // Entrer
    { path: 'entree/:insertOrList', component: EntreeComponent },
    { path: 'ajoutentree', component: AjoutEntreeComponent },
    { path: 'deleteentree/:id', component: DeleteEntreeComponent },

    // Plat
    { path: 'plat/:insertOrList', component: PlatComponent },
    { path: 'ajoutplat', component: AjoutPlatComponent },
    { path: 'deleteplat/:id', component: DeletePlatComponent },

    // Dessert
    { path: 'dessert/:insertOrList', component: DessertComponent },
    { path: 'ajoutdessert', component: AjoutDessertComponent },
    { path: 'deletedessert/:id', component: DeleteDessertComponent },

    // Boisson
    { path: 'boisson/:insertOrList', component: BoissonComponent },
    { path: 'ajoutboisson', component: AjoutBoissonComponent },
    { path: 'deleteboisson/:id', component: DeleteBoissonComponent },
];

export const adminRouting = RouterModule.forChild(routes);
