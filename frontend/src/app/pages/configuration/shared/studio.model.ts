export class StudioModel {
  constructor(
    public id?: number,
    public name?: string,
    public phone?: string,
    public description?: string,
    public cnpj?: string,
    public telephone?: string,
    public has_parking?: number,
    public is_24_hours?: number,
    public city_id?: number,
    public rate_cancellation?: number,
    public days_cancellation?: number,
    public zip_code?: string,
    public street?: string,
    public complement?: string,
    public distrct?: string,
    public number?: string,
    public image?: string,
    public email?: string
  ) {}
}
