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

  private jsonDataToSchedules(jsonData: any): ScheduleModel[] {
    const schedules: ScheduleModel[] = [];

    jsonData['schedules'].forEach(element => {
      const sched = Object.assign(new ScheduleModel(), element)
      schedules.push(sched);
      console.log('sched ', sched);
    });

    return schedules;
  }

  private handleError(error: any): Observable<any> {
    console.log('Erro na requisição => ', error);

    return throwError(error);
  }
}
