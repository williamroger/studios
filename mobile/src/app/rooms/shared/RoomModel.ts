export class RoomModel {
  constructor(
    public id?: number,
    public name?: string,
    public description?: string,
    public studio_id?: number,
    public maximum_capacity?: number,
    public color?: string,
    public image?: string,
    public created_at?: string,
    public updated_at?: string,
  ) {}

  get imageRoom() {
    let imagepath = './assets/room-default.jpg';

    if (this.image) {
      const image = this.image;
      imagepath = 'http://localhost:8080/' + image.substr(image.indexOf('App'), image.length);

      return imagepath;
    }

    return imagepath;
  }
}