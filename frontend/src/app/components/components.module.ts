import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { HeaderMenuComponent } from './header-menu/header-menu.component';

@NgModule({
  declarations: [
    HeaderMenuComponent
  ],
  exports: [
    HeaderMenuComponent
  ],
  imports: [
    CommonModule,
  ]
})
export class ComponentsModule { }
