import { map, catchError } from 'rxjs/operators';
import { RoomModel } from './RoomModel';
import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class RoomService {

  public API_URL = 'http://localhost:8080/';

  constructor(public http: HttpClient) { }

  getRooms(): Observable<RoomModel[]> {
    return this.http.get(this.API_URL + 'studio/getallrooms').pipe(
      catchError(this.handleError),
      map(this.jsonDataToRooms)
    );
  }

  getRoomsByStudio(idStudio: number): Observable<RoomModel[]> {
    return this.http.get(this.API_URL + `studio/getroomsbystudioid/${idStudio}`).pipe(
      catchError(this.handleError),
      map(this.jsonDataToRooms)
    );
  }

  private jsonDataToRooms(jsonData: any[]): RoomModel[] {
    const rooms: RoomModel[] = [];
    jsonData['rooms'].forEach(element => rooms.push(element as RoomModel));
    return rooms;
  }

  private handleError(error: any): Observable<any> {
    console.log('Erro na Requisição => ', error);
    return throwError(error);
  }
}