import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { StudioFormComponent } from './studio-form/studio-form.component';


const routes: Routes = [
  { path: '', component: StudioFormComponent }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class RegisterRoutingModule { }
