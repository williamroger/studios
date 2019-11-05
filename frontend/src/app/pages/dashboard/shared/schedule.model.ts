export class ScheduleModel {
  constructor(
    public id?: number,
    public schedule_id?: number,
    public time_period_id?: number,
    public status?: number,
    public date_cancellation?: string,
    public created_at?: string,
    public updated_at?: string,
    public customer_id?: number,
    public comment?: string,
    public date_scheduling?: string,
    public amount?: number,
    public room_id?: number,
    public day?: number,
    public price_rate?: number,
    public begin_period?: string,
    public end_period?: string,
    public day_order?: number,
    public description?: string,
    public studio_id?: number,
    public name?: string,
    public maximum_capacity?: number,
    public color?: string,
    public image?: string,
    public firstname?: string,
    public lastname?: string,
    public phone?: string,
    public cpf?: string,
    public city_id?: number
  ) {}

  get beginPeriod() {
    return this.begin_period.slice(0, 5);
  }

  get endPeriod() {
    return this.end_period.slice(0, 5);
  }

  get statusText() {
    if (this.status == 0) {
      return 'Aguardando';
    } else if (this.status == 1) {
      return 'Confirmado';
    } else {
      return 'Cancelado';
    }
  }
}
