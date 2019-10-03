import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule } from '@angular/forms';

import { RoomsRoutingModule } from './rooms-routing.module';
import { RoomFormComponent } from './room-form/room-form.component';
import { RoomListComponent } from './room-list/room-list.component';

import { IMaskModule } from 'angular-imask';
import { PeriodListComponent } from './period-list/period-list.component';
import { PeriodFormComponent } from './period-form/period-form.component';

@NgModule({
  declarations: [RoomFormComponent, RoomListComponent, PeriodListComponent, PeriodFormComponent],
  imports: [
    CommonModule,
    RoomsRoutingModule,
    ReactiveFormsModule,
    IMaskModule
  ]
})
export class RoomsModule { }
