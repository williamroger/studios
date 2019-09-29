import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule } from '@angular/forms';
import { ConfigurationRoutingModule } from './configuration-routing.module';
import { StudioFormComponent } from './studio-form/studio-form.component';


@NgModule({
  declarations: [StudioFormComponent],
  imports: [
    CommonModule,
    ConfigurationRoutingModule,
    ReactiveFormsModule
  ]
})
export class ConfigurationModule { }
