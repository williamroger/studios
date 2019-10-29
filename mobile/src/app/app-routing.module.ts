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
    loadChildren: './tabs/tabs.module#TabsPageModule',
    canActivate: [AuthGuard]
  },
  {
    path: ':id/rooms',
    loadChildren: './rooms/rooms.module#RoomsPageModule',
    canActivate: [AuthGuard]
  },
  {
    path: ':id/rooms/:idroom/details',
    loadChildren: './room-details/room-details.module#RoomDetailsPageModule',
    canActivate: [AuthGuard]
  }

];
@NgModule({
  imports: [
    RouterModule.forRoot(routes, { preloadingStrategy: PreloadAllModules })
  ],
  exports: [RouterModule]
})
export class AppRoutingModule {}
/*
,
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
  },
  { path: 'schedules', loadChildren: './schedules/schedules.module#SchedulesPageModule' }
*/