import { NgModule } from '@angular/core';
import { PreloadAllModules, RouterModule, Routes } from '@angular/router';

import { AuthGuard } from './auth.guard';

const routes: Routes = [
  { path: '', 
    loadChildren: './login/login.module#LoginPageModule' 
  },
  { path: 'register', 
    loadChildren: './register/register.module#RegisterPageModule' 
  },
  {
    path: 'tabs',
    loadChildren: () => import('./tabs/tabs.module').then(m => m.TabsPageModule),
    canActivate: [AuthGuard]
  },
  { path: 'rooms', 
    loadChildren: './rooms/rooms.module#RoomsPageModule',
    canActivate: [AuthGuard]
  },
  { path: 'info-room', 
    loadChildren: './info-rooms/info-rooms.module#InfoRoomsPageModule'
  },
  { path: 'scheduling', 
    loadChildren: './scheduling/scheduling.module#SchedulingPageModule',
    canActivate: [AuthGuard] 
  },  { path: 'schedules', loadChildren: './schedules/schedules.module#SchedulesPageModule' }

];
@NgModule({
  imports: [
    RouterModule.forRoot(routes, { preloadingStrategy: PreloadAllModules })
  ],
  exports: [RouterModule]
})
export class AppRoutingModule {}
