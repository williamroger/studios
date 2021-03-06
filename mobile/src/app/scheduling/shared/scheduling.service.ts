import { Injectable, EventEmitter  } from '@angular/core';
import { HttpClient, HttpHeaders} from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { map, catchError, flatMap } from 'rxjs/operators';
import { PeriodModel } from './PeriodModel';
import { SchedulingModel } from './SchedulingModel';

@Injectable({
  providedIn: 'root'
})
export class SchedulingService {

  public userLocalStorage = JSON.parse(localStorage.getItem('userLoggedIn'));

  constructor(public http: HttpClient) { }

  getPeriodsByRoomId(id: number): Observable<PeriodModel[]> {
    return this.http.get(`api/studio/getperiodsbyroomid/${id}`).pipe(
      catchError(this.handleError),
      map(this.jsonDataToPeriods)
    )
  }

  getPeriodsFreeByRoomIdAndDate(id: number, day: string, date: string): Observable<PeriodModel[]> {
    return this.http.get(`api/getperiodsfreebyroomidanddate/${id}/${day}/${date}`).pipe(
      catchError(this.handleError),
      map(this.jsonDataToPeriods)
    )
  }

  insertScheduling(scheduling: SchedulingModel): Observable<SchedulingModel> {
    return this.http.post('api/newschedule', scheduling).pipe(
      catchError(this.handleError),
      map(this.jsonDataToScheduling)
    )
  }

  private jsonDataToPeriods(jsonData: any[]): PeriodModel[] {
    const periods: PeriodModel[] = [];

    if (jsonData['success']) {
      jsonData['periods'].forEach(element => {
        const period = Object.assign(new PeriodModel(), element);

        periods.push(period);
      });

    } else {
      periods.push(jsonData['msg']);
    }

    return periods;

  }

  private jsonDataToScheduling(jsonData: any): SchedulingModel {
    return jsonData as SchedulingModel;
  }

  private handleError(error: any): Observable<any> {
    console.log('Erro na RequisiÃ§Ã£o => ', error);

    return throwError(error);
  }

}
