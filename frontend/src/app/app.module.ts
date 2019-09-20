
import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { HttpClientModule } from '@angular/common/http';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { StudioFormUpdateModule } from './pages/register/studio-form-update/studio-form-update.module';



@NgModule({
  declarations: [
    AppComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpClientModule,
    StudioFormUpdateModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
