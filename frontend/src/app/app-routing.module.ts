import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { AuthGuard } from './auth.guard';
import { LogoutComponent } from './pages/logout/logout.component';

const routes: Routes = [
  { path: '',
    pathMatch: 'full',
    redirectTo: 'login'
  },
  {
    path: 'login',
    loadChildren: './pages/login/login.module#LoginModule'
  },
  { path: 'dashboard',
    loadChildren: './pages/dashboard/dashboard.module#DashboardModule',
    canActivate: [AuthGuard]
  },
  { path: 'cadastro',
    loadChildren: './pages/register/register.module#RegisterModule',
    canActivate: [AuthGuard]
  },
  { path: 'configuracoes',
    loadChildren: './pages/configuration/configuration.module#ConfigurationModule',
    canActivate: [AuthGuard]
  },
  { path: 'salas',
    loadChildren: './pages/rooms/rooms.module#RoomsModule',
    canActivate: [AuthGuard]
  },
  {
    path: 'logout',
    component: LogoutComponent
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
