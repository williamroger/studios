import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { map, catchError } from 'rxjs/operators';
import { ScheduleModel } from './schedule.model';

@Injectable({
  providedIn: 'root'
})
export class SchedulingService {

  constructor(private http: HttpClient) { }

  getSchedulesByStudioIdAndDate(id: number, date: string): Observable<ScheduleModel[]> {
    return this.http.get(`api/getschedulesbystudioidanddate/${id}/${date}`).pipe(
      catchError(this.handleError),
      map(this.jsonDataToSchedules)
    )
  }

  confirmScheduling(schedule: ScheduleModel): Observable<any> {
    return this.http.put(`api/confirmscheduling`, schedule).pipe(
      catchError(this.handleError),
      map(this.jsonDataToMessage)
    )
  }

  cancelScheduling(schedule: ScheduleModel): Observable<any> {
    return this.http.put(`api/cancelscheduling`, schedule).pipe(
      catchError(this.handleError),
      map(this.jsonDataToMessage)
    )
  }

  private jsonDataToSchedules(jsonData: any): ScheduleModel[] {
    const schedules: ScheduleModel[] = [];

    if (jsonData['success']) {
      jsonData['schedules'].forEach(element => {
        const sched = Object.assign(new ScheduleModel(), element)
        schedules.push(sched);
      });
    } else {
      schedules.push(jsonData['msg']);
    }

    return schedules;
  }

  private jsonDataToMessage(jsonData: any): string {
    let message = '';
    message = jsonData['msg'];
    return message;
  }

  private handleError(error: any): Observable<any> {
    console.log('Erro na requisição => ', error);

    return throwError(error);
  }
}
