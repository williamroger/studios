import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';

import { Observable, throwError} from 'rxjs';
import { map, catchError, flatMap} from 'rxjs/operators';

import { StudioModel } from './studio.model';

@Injectable({
  providedIn: 'root'
})
export class RegisterService {

  private apiPath: string = 'http://localhost:8080';

  constructor(public http: HttpClient) { }

  createStudio(studio: StudioModel): Observable<StudioModel> {
    return this.http.post(`${this.apiPath}/studio/insertstudio` , studio).pipe(
      catchError(this.handleError),
      map(this.jsonDataToStudio)
    );
  }

  /**
   * Private Methods
   */
  private jsonDataToStudio(jsonData: any): StudioModel {
    return jsonData as StudioModel;
  }

  private handleError(error: any): Observable<any> {
    console.log('Erro na Requisição => ', error);

    return throwError(error);
  }
}
