import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

import { Observable, throwError } from 'rxjs';
import { map, catchError, flatMap } from 'rxjs/operators';

import { UserModel } from './pages/login/shared/user.model';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  private loggedInStatus = JSON.parse(localStorage.getItem('loggedIn') || 'false');

  constructor(private http: HttpClient) { }

  login(user: UserModel): Observable<any> {
    return this.http.post('api/login', user).pipe(
      catchError(this.handleError)
    )
  }

  setLoggedIn(value: boolean) {
    this.loggedInStatus = value;
    localStorage.setItem('loggedIn', 'true');
  }

  get isLoggedIn() {
    return JSON.parse(localStorage.getItem('loggedIn') || this.loggedInStatus.toString());
  }

  /**
 * Private Methods
 */
  // private jsonDataToStudio(jsonData: any): StudioModel {
  //   return jsonData as StudioModel;
  // }

  private handleError(error: any): Observable<any> {
    // provisório
    console.log('Erro na Requisição => ', error);

    return throwError(error.error);
  }
}
