import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';


const routes: Routes = [
  { path: '', loadChildren: './pages/login/login.module#LoginModule' },
  { path: 'cadastro', loadChildren: './pages/register/register.module#RegisterModule'},
  { path: 'configuracoes', loadChildren: './pages/configuration/configuration.module#ConfigurationModule' }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
