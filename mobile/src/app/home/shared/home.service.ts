import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';

import { Observable, throwError } from 'rxjs';
import { map, catchError, flatMap } from 'rxjs/operators';

import { IonApp, NavController, NavParams, ToastController, IonInfiniteScroll } from '@ionic/angular';
import { ViewChild } from '@angular/core';

const headers = new HttpHeaders({
 
});

import {StudioModel} from '../shared/StudioModel';


@Injectable({
  providedIn: 'root'
})
export class HomeService {

  constructor(public http: HttpClient) { }

  public getAllStudios(): Observable<StudioModel>{
    return this.http.get('api/customer/updatecustomer');
  }

  public getById(id: number): Observable<StudioModel> {
    return this.http.get(`api/studio/getroombyid/${id}`);
  }
}
