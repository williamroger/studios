import { UserModel } from './UserModel';
import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, throwError } from 'rxjs';
import { map, catchError, flatMap } from 'rxjs/operators';


@Injectable({
  providedIn: 'root'
})
export class AuthService {

  private loggedStatus = JSON.parse(localStorage.getItem('loggedIn') || 'false');
  private userLocalStorage = JSON.parse(localStorage.getItem('userLoggedIn'));

  constructor(public http: HttpClient) { }

  login(user: UserModel): Observable<any> {
    return this.http.post('api/login', user).pipe(
      catchError(this.handleError)
    )
  }

  setLoggedIn(value: boolean) {
    this.loggedStatus = value;
    localStorage.setItem('loggedIn', 'true');
  }

  get IsLoggedIn() {
    return JSON.parse(localStorage.getItem('loggedIn') || this.loggedStatus.toSring());
  }

  get userLoggedIn() {
    return this.userLocalStorage;
  }

  private handleError(error: any): Observable<any> {
    console.log('Erro na Requisição => ', error);

    return throwError(error.error);
  }

}
