import { CustomerModel } from './customerModel';
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

  constructor(public http: HttpClient) { }

  updateCustomer(customer: CustomerModel): Observable<CustomerModel> {
    return this.http.put('api/customer/updatecustomer' + customer.id, customer).pipe(
      catchError(this.handleError),
      map(this.jsonDataToCustomer)
    )
  }

     /**
 * Private Methods
 */
private jsonDataToCustomer(jsonData: any): CustomerModel {
  return jsonData as CustomerModel;
}

private handleError(error: any): Observable<any> {
  console.log('Erro na Requisição => ', error);
  return throwError(error);
}
}
