export class PeriodModel {
  constructor(
    public id?: number,
    public room_id?: number,
    public amount?: string,
    public day?: string,
    public price_rate?: number,
    public begin_period?: string,
    public end_period?: string,
    public created_at?: string,
    public updated_at?: string
  ) { }
}
