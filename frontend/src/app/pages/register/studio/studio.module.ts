import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { StudioRoutingModule } from './studio-routing.module';
import { RegisterFormComponent } from './register-form/register-form.component';


@NgModule({
  declarations: [RegisterFormComponent],
  imports: [
    CommonModule,
    StudioRoutingModule
  ]
})
export class StudioModule { }
