import { map, catchError } from 'rxjs/operators';
import {StudioModel} from '../shared/StudioModel';
import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';


@Injectable({
  providedIn: 'root'
})

export class HomeService {

  private userLocalStorage = JSON.parse(localStorage.getItem('userLoggedIn'));
  public API_URL = 'http://localhost:8080/';

  constructor(public http: HttpClient) { }

  public studio: StudioModel;
  
  getStudiosByCityIdCustomer() {
    const idCustomer = this.userLocalStorage['customer_id'];
    return this.http.get(`api/customer/getstudiosbycityidcustomer/${idCustomer}`).pipe(
      catchError(this.handleError),
      map(this.jsonDataToStudios)
    );
  }

  public takeIndex(studio: StudioModel){
    this.studio = studio;
  }

  public returnStudio(){
    return this.studio;
  }

  private jsonDataToStudios(jsonData: any[]): StudioModel[] {
    const studios: StudioModel[] = [];
    jsonData['studios'].forEach(element => studios.push(element as StudioModel));
    return studios;
  }

  private handleError(error: any): Observable<any> {
    console.log('Erro na Requisição => ', error);
    return throwError(error);
  }

}
