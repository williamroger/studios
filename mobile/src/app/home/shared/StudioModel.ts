export class StudioModel {
  constructor(
    public id?: number,
    public name?: string,
    public phone?: string,
    public description?: string,
    public cnpj?: string,
    public telephone?: string,
    public created_at?: string,
    public updated_at?: string,
    public has_parking?: number,
    public has_wifi?: number,
    public has_recording?: number,
    public has_mixing_mastering?: number,
    public is_24_hours?: number,
    public city_id?: number,
    public rate_cancellation?: number,
    public days_cancellation?: number,
    public zip_code?: string,
    public street?: string,
    public complement?: string,
    public district?: string,
    public number?: string,
    public image?: string, 
  ) { }

  get logoStudio() {
    let logopath = './assets/studios.png';

    if (this.image) {
      let path = this.image;
      logopath = 'http://localhost:8080/' + path.substr(path.indexOf('App'), path.length);

      return logopath;
    }

    return logopath;
  }
}