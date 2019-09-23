import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders} from '@angular/common/http';

import { Observable, throwError } from 'rxjs';
import { map, catchError, flatMap } from 'rxjs/operators';

import { RoomModel } from './room.model';

@Injectable({
  providedIn: 'root'
})
export class RoomsService {

  constructor(private http: HttpClient) { }

  getAll(): Observable<RoomModel[]> {
    return this.http.get('api/studio/getallrooms').pipe(
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
      map(() => null)
    );
  }

  /**
 * Private Methods
 */
  private jsonDataToRooms(jsonData: any[]): RoomModel[] {
    const rooms: RoomModel[] = [];
    jsonData.forEach(element => rooms.push(element as RoomModel));
    return rooms;
  }

  private jsonDataToRoom(jsonData: any): RoomModel {
    return jsonData as RoomModel;
  }

  private handleError(error: any): Observable<any> {
    console.log('Erro na Requisição => ', error);

    return throwError(error);
  }
}
