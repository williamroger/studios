import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule } from '@angular/forms';

import { RoomsRoutingModule } from './rooms-routing.module';
import { RoomFormComponent } from './room-form/room-form.component';
import { RoomListComponent } from './room-list/room-list.component';


@NgModule({
  declarations: [RoomFormComponent, RoomListComponent],
  imports: [
    CommonModule,
    RoomsRoutingModule,
    ReactiveFormsModule
  ]
})
export class RoomsModule { }