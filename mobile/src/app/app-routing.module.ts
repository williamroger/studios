import { NgModule } from '@angular/core';
import { PreloadAllModules, RouterModule, Routes } from '@angular/router';

const routes: Routes = [
  {
    path: 'tabs',
    loadChildren: () => import('./tabs/tabs.module').then(m => m.TabsPageModule)
  },
  { path: 'register', loadChildren: './register/register.module#RegisterPageModule' },
  { path: '', loadChildren: './login/login.module#LoginPageModule' },
  { path: 'room', loadChildren: './rooms/rooms.module#RoomsPageModule' },  { path: 'info-rooms', loadChildren: './info-rooms/info-rooms.module#InfoRoomsPageModule' },
  { path: 'scheduling', loadChildren: './scheduling/scheduling.module#SchedulingPageModule' },

];
@NgModule({
  imports: [
    RouterModule.forRoot(routes, { preloadingStrategy: PreloadAllModules })
  ],
  exports: [RouterModule]
})
export class AppRoutingModule {}
