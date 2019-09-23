import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { RoomListComponent } from './room-list/room-list.component';
import { RoomFormComponent } from './room-form/room-form.component';

const routes: Routes = [
  { path: '', component: RoomListComponent, },
  { path: 'new', component: RoomFormComponent, },
  { path: ':id/edit', component: RoomFormComponent, }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class RoomsRoutingModule { }
