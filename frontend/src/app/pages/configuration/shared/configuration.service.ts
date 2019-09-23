import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';

import { Observable, throwError } from 'rxjs';
import { map, catchError, flatMap} from 'rxjs/operators';

import { StudioModel } from './studio.model';
import { StateModel } from './state.model';

@Injectable({
  providedIn: 'root'
})
export class ConfigurationService {

  constructor(public http: HttpClient) { }

  getAllStates(): Observable<StateModel[]> {
    return this.http.get('api/getallstates').pipe(
      catchError(this.handleError),
      map(this.jsonDataToState)
    );
  }

  /**
   * Private Methods
   */
  private jsonDataToState(jsonData: any[]): StateModel[] {
    const states: StateModel[] = [];
    jsonData.forEach(element => states.push(element as StateModel));
    return states;
  }

  private handleError(error: any): Observable<any> {
    console.log('Erro na Requisição => ', error);

    return throwError(error);
  }
}
