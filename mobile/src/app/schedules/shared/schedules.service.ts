import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { ScheduleModel } from './scheduleModel';
import { Observable, throwError } from 'rxjs';
import { map, catchError } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class SchedulesService {

  public userLocalStorage = JSON.parse(localStorage.getItem('userLoggedIn'));

  constructor(public http: HttpClient) { }

  getSchedulesByCustomer(): Observable<ScheduleModel[]> {
    const id = this.userLocalStorage['customer_id'];

    return this.http.get(`api/getschedulesbycustomerid/${id}`).pipe(
      catchError(this.handleError),
      map(this.jsonDataToSchedules)
    )
  }

  cancelScheduling(schedule: ScheduleModel): Observable<any> {
    return this.http.put(`api/usercancelscheduling`, schedule).pipe(
      catchError(this.handleError),
      map(this.jsonDataToMessage)
    )
  }

  private jsonDataToSchedules(jsonData: any[]): ScheduleModel[] {
    const schedules: ScheduleModel[] = [];

    if (jsonData['success']) {
      jsonData['schedules'].forEach(element => {
        const sched = Object.assign(new ScheduleModel(), element);

        schedules.push(sched);
      });
    } else {
      schedules.push(jsonData['msg']);
    }

    return schedules;
  }

  private handleError(error: any): Observable<any> {
    console.log('Erro na RequisiÃ§Ã£o => ', error);

    return throwError(error);
  }

  private jsonDataToMessage(jsonData: any): string {
    let message = '';
    message = jsonData['msg'];
    return message;
  }
}
