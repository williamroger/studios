import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule } from '@angular/forms';

import { ConfigurationRoutingModule } from './configuration-routing.module';
import { StudioFormComponent } from './studio-form/studio-form.component';

import { IMaskModule } from 'angular-imask';

@NgModule({
  declarations: [StudioFormComponent],
  imports: [
    CommonModule,
    ConfigurationRoutingModule,
    ReactiveFormsModule,
    IMaskModule
  ]
})
export class ConfigurationModule { }
