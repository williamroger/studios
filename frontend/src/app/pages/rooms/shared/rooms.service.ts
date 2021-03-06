import { Injectable, EventEmitter } from '@angular/core';
import { HttpClient, HttpHeaders} from '@angular/common/http';

import { Observable, throwError } from 'rxjs';
import { map, catchError, flatMap } from 'rxjs/operators';

import { RoomModel } from './room.model';
import { PeriodModel } from './period.model';

@Injectable({
  providedIn: 'root'
})
export class RoomsService {

  private userLocalStorage = JSON.parse(localStorage.getItem('userLoggedIn'));

  constructor(private http: HttpClient) { }

  // Métodos Salas
  getRoomsByStudioId(): Observable<RoomModel[]> {
    const idStudio = this.userLocalStorage['studio_id'];

    return this.http.get(`api/studio/getroomsbystudioid/${idStudio}`).pipe(
      catchError(this.handleError),
      map(this.jsonDataToRooms)
    )
  }

  getById(id: number): Observable<RoomModel> {
    return this.http.get(`api/studio/getroombyid/${id}`).pipe(
      catchError(this.handleError),
      map(this.jsonDataToRoom)
    )
  }

  create(room: RoomModel): Observable<RoomModel> {
    return this.http.post('api/studio/insertroom', room).pipe(
      catchError(this.handleError),
      map(this.jsonDataToRoom)
    )
  }

  update(room: RoomModel): Observable<RoomModel> {
    return this.http.put('api/studio/updateroom', room).pipe(
      catchError(this.handleError),
      map(() => room)
    );
  }

  delete(id: number): Observable<any> {
    return this.http.delete(`api/studio/deleteroom/${id}`).pipe(
      catchError(this.handleError),
      map((data) => data)
    );
  }

  // Métodos de Período
  createPeriod(period: PeriodModel): Observable<PeriodModel> {

    return this.http.post('api/studio/insertperiod', period).pipe(
      catchError(this.handleError),
      map(this.jsonDataToPeriod)
    )
  }

  updatePeriod(period: PeriodModel): Observable<PeriodModel> {
    return this.http.put('api/studio/updateperiod', period).pipe(
      catchError(this.handleError),
      map(() => period)
    )
  }

  deletePeriod(id: number): Observable<any> {
    return this.http.delete(`api/studio/deleteperiod/${id}`).pipe(
      catchError(this.handleError),
      map((data) => data)
    )
  }

  getPeriodsByRoomId(id: number): Observable<PeriodModel[]> {
    return this.http.get(`api/studio/getperiodsbyroomid/${id}`).pipe(
      catchError(this.handleError),
      map(this.jsonDataToPeriods)
    )
  }

  getPeriodById(id: number): Observable<PeriodModel> {
    return this.http.get(`api/studio/getperiodbyid/${id}`).pipe(
      catchError(this.handleError),
      map(this.jsonDataToPeriod)
    )
  }

  uploadImage(formData: FormData, idRoom: number): Observable<any> {
    const idStudio = this.userLocalStorage['studio_id'];

    return this.http.post(`api/studio/${idStudio}/room/${idRoom}/imageupload`, formData, { reportProgress: true, observe: 'events' });
  }

  // Private Methods
  private jsonDataToPeriods(jsonData: any[]): PeriodModel[] {
    const periods: PeriodModel[] = [];

    jsonData['periods'].forEach(element => {
      const period = Object.assign(new PeriodModel(), element);
      periods.push(period);
    });

    return periods;
  }

  private jsonDataToRooms(jsonData: any[]): RoomModel[] {
    const rooms: RoomModel[] = [];

    jsonData['rooms'].forEach(element => {
      const room = Object.assign(new RoomModel(), element);
      rooms.push(room);
    });

    return rooms;
  }

  private jsonDataToRoom(jsonData: any): RoomModel {
    return Object.assign(new RoomModel(), jsonData['room']);
  }

  private jsonDataToPeriod(jsonData: any): PeriodModel {
    return Object.assign(new PeriodModel(), jsonData['period']);
  }

  private handleError(error: any): Observable<any> {
    console.log('Erro na Requisição => ', error);

    return throwError(error);
  }
}
