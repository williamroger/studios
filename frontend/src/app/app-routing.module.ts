import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';


const routes: Routes = [
  { path: '', loadChildren: './pages/login/login.module#LoginModule' },
  { path: 'dashboard', loadChildren: './pages/dashboard/dashboard.module#DashboardModule' },
  { path: 'cadastro', loadChildren: './pages/register/register.module#RegisterModule'},
  { path: 'configuracoes', loadChildren: './pages/configuration/configuration.module#ConfigurationModule' },
  { path: 'salas', loadChildren: './pages/rooms/rooms.module#RoomsModule' }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
