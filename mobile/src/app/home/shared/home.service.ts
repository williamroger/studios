import { map, catchError } from 'rxjs/operators';
import {StudioModel} from '../shared/StudioModel';
import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';


@Injectable({
  providedIn: 'root'
})

export class HomeService {

  public API_URL = 'http://localhost:8080/';

  constructor(public http: HttpClient) { }

  public studio: StudioModel;

  getStudios(): Observable<StudioModel[]> {
    return this.http.get(this.API_URL + 'studio/getallstudios').pipe(
      catchError(this.handleError),
      map(this.jsonDataToStudios)
    );
  }

  /*getStudiosById(): Observable<StudioModel[]> {
    return this.http.get(this.API_URL + 'studio/getstudiobyid/1').pipe(
      catchError(this.handleError),
      map(this.jsonDataToStudios)
    );
  }*/

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
