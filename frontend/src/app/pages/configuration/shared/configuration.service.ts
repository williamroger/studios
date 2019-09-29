import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';

import { Observable, throwError } from 'rxjs';
import { map, catchError, flatMap} from 'rxjs/operators';

import { StudioModel } from './studio.model';
import { CityModel } from './city.mode';


@Injectable({
  providedIn: 'root'
})
export class ConfigurationService {

  private userLocalStorage = JSON.parse(localStorage.getItem('userLoggedIn'));

  constructor(public http: HttpClient) { }

  getCitiesByStateId(): Observable<CityModel[]> {
    return this.http.get('api/getcitiesbystateid/17').pipe(
      catchError(this.handleError),
      map(this.jsonDataToCities)
    );
  }

  getStudioById(): Observable<StudioModel> {
    const id = this.userLocalStorage['studio_id'];
    return this.http.get(`api/studio/getstudiobyid/${id}`).pipe(
      catchError(this.handleError),
      map(this.jsonDataToStudio)
    )
  }

  /**
   * Private Methods
   */
  private jsonDataToCities(jsonData: any[]): CityModel[] {

    const cities: CityModel[] = [];
    jsonData['cities'].forEach(element => cities.push(element as CityModel));
    return cities;
  }

  private jsonDataToStudio(jsonData: any): StudioModel {
    return jsonData as StudioModel;
  }

  private handleError(error: any): Observable<any> {
    console.log('Erro na Requisição => ', error);

    return throwError(error);
  }
}
