import { Component, OnInit, ViewChild } from '@angular/core';
import { IonApp, NavController, ToastController, IonInfiniteScroll } from '@ionic/angular';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { HomeService } from './shared/home.service';

import { Observable, throwError } from 'rxjs'; 

export enum SearchType {
  all = '',
  studios = 'studios'
}

@Component({
  selector: 'app-home',
  templateUrl: './home.page.html',
  styleUrls: ['./home.page.scss'],
})
export class HomePage implements OnInit {

  public studios: any[]; 
  type: SearchType = SearchType.studios;

  constructor(public navCtrl: NavController, 
    private toast: ToastController, 
    public homeService:HomeService,
    public http: HttpClient) { this.getAllStudios();}

  getAllStudios() {
    /*this.studios = [
      {name:"estudio1"},
      {name:"estudio1"},
      {name:"estudio1"},
      {name:"estudio1"},
    ]*/
    let data: Observable<any>;
    data = this.http.get('http://localhost:8080/studio/getallstudios');
    data.subscribe(result=>{
      this.studios = result;
    })
  }

  ngOnInit() {
  }

}
