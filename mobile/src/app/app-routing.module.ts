import { NgModule } from '@angular/core';
import { PreloadAllModules, RouterModule, Routes } from '@angular/router';

const routes: Routes = [
  {
    path: 'tabs',
    loadChildren: () => import('./tabs/tabs.module').then(m => m.TabsPageModule)
  },
  { path: 'register', loadChildren: './register/register.module#RegisterPageModule' },
  { path: '', loadChildren: './login/login.module#LoginPageModule' },
  { path: 'room', loadChildren: './rooms/rooms.module#RoomsPageModule' },  { path: 'studio-modal', loadChildren: './studio-modal/studio-modal.module#StudioModalPageModule' }

];
@NgModule({
  imports: [
    RouterModule.forRoot(routes, { preloadingStrategy: PreloadAllModules })
  ],
  exports: [RouterModule]
})
export class AppRoutingModule {}
