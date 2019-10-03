

import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { DashboardRoutingModule } from './dashboard-routing.module';
import { DashboardComponent } from './dashboard/dashboard.component';
import { HeaderMenuModule } from './../../shared/header-menu/header-menu/header-menu.module';
import { HeaderMenuComponent } from './../../shared/header-menu/header-menu/header-menu.component';

@NgModule({
  declarations: [
    DashboardComponent,
    HeaderMenuComponent
  ],
  imports: [
    CommonModule,
    DashboardRoutingModule,
    HeaderMenuModule
  ]
})
export class DashboardModule { }
