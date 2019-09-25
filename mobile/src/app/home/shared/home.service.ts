import { StudioModel } from './StudioModel';
import { Observable } from  'rxjs/Observable';
import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';


@Injectable({
  providedIn: 'root'
})
export class HomeService {

  constructor(public http: HttpClient) { }

  public getAllStudios() Observable<StudioModel>{
    return this.http.get('api/customer/updatecustomer');
  }

}
