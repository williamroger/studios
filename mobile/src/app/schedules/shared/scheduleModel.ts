export class ScheduleModel {
  constructor(
    public id?: number,
    public schedule_id?: number,
    public time_period_id?: number,
    public studio_name?: string,
    public status?: number,
    public date_cancellation?: string,
    public created_at?: string,
    public updated_at?: string,
    public customer_id?: number,
    public comment?: string,
    public date_scheduling?: string,
    public amount?: string,
    public room_id?: number,
    public day?: string,
    public price_rate?: string,
    public begin_period?: string,
    public end_period?: string,
    public day_order?: number,
    public studio_id?: number,
    public room_name?: string,
    public maximum_capacity?: number
  ) {}

  get schedulingDate() {
    let schedulingDate = '';
    const year = this.date_scheduling.slice(0, 4);
    const month = this.date_scheduling.slice(5, 7);
    const day = this.date_scheduling.slice(8, 10);

    switch (month) {
      case '01':
        schedulingDate = `${day} de Janeiro de ${year}`;
        break;
      case '02':
        schedulingDate = `${day} de Fevereiro de ${year}`;
        break;
      case '03':
        schedulingDate = `${day} de Março de ${year}`;
        break;
      case '04':
        schedulingDate = `${day} de Abril de ${year}`;
        break;
      case '05':
        schedulingDate = `${day} de Maio de ${year}`;
        break;
      case '06':
        schedulingDate = `${day} de Junho de ${year}`;
        break;
      case '07':
        schedulingDate = `${day} de Julho de ${year}`;
        break;
      case '08':
        schedulingDate = `${day} de Agosto de ${year}`;
        break;
      case '09':
        schedulingDate = `${day} de Setembro de ${year}`;
        break;
      case '10':
        schedulingDate = `${day} de Outubro de ${year}`;
        break;
      case '11':
        schedulingDate = `${day} de Novembro de ${year}`;
        break;
      case '12':
        schedulingDate = `${day} de Dezembro de ${year}`;
        break;
    }

    return schedulingDate;
  }

  get cancellationDate() {
    const year = this.date_cancellation.slice(0, 4);
    const month = this.date_cancellation.slice(5, 7);
    const day = this.date_cancellation.slice(8, 10);

    return `${day}/${month}/${year}`;
  }

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