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

  public room: RoomModel;

  setRoom(room: RoomModel){
    this.room = room;
  }

  getRoom(){
    return this.room;
  }

  getRoomsByStudioID(idStudio: number): Observable<RoomModel[]> {
    return this.http.get(this.API_URL + `studio/getroomsbystudioid/${idStudio}`).pipe(
      catchError(this.handleError),
      map(this.jsonDataToRooms)
    );
  }

  private jsonDataToRooms(jsonData: any[]): RoomModel[] {
    const rooms: RoomModel[] = [];

    jsonData['rooms'].forEach(element => {
      const room = Object.assign(new RoomModel(), element);
      rooms.push(room);
    });
    
    return rooms;
  }

  private handleError(error: any): Observable<any> {
    console.log('Erro na Requisição => ', error);
    return throwError(error);
  }
}