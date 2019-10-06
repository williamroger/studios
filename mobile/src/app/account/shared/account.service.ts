import { CustomerModel } from './customerModel';
import { CityModel } from './CityModel';
import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';

import { Observable, throwError } from 'rxjs';
import { map, catchError, flatMap } from 'rxjs/operators';

const headers = new HttpHeaders({
});

@Injectable({
  providedIn: 'root'
})
export class AccountService {

  private userLocalStorage = JSON.parse(localStorage.getItem('userLoggedIn'));

  constructor(public http: HttpClient) { }

  updateCustomer(customer: CustomerModel): Observable<any> {
    return this.http.put('api/customer/updatecustomer', customer).pipe(
      catchError(this.handleError),
      map(() => customer)
    )
  }

  getCustomerById(): Observable<CustomerModel> {
    const idCustomer = this.userLocalStorage['customer_id'];
    return this.http.get(`api/customer/getcustomerbyid/${idCustomer}`).pipe(
      catchError(this.handleError),
      map(this.jsonDataToCustomer)
    )
  }

  getCitiesByStateId(): Observable<CityModel[]> {
    return this.http.get('api/getcitiesbystateid/17').pipe(
      catchError(this.handleError),
      map(this.jsonDataToCities)
    );
  }


     /**
 * Private Methods
 */
private jsonDataToCities(jsonData: any[]): CityModel[] {
  const cities: CityModel[] = [];

  jsonData['cities'].forEach(element => cities.push(element as CityModel));
  return cities;
}


private jsonDataToCustomer(jsonData: any): CustomerModel {
  return Object.assign(new CustomerModel(), jsonData['customer']);
  //return jsonData as CustomerModel;
}

private handleError(error: any): Observable<any> {
  console.log('Erro na Requisição => ', error);
  return throwError(error);
}
}
