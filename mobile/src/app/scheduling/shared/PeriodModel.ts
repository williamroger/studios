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
      public updated_at?: string,
    ) { }
  
    get dayText() {
      let day = '';
  
      switch (this.day) {
        case 'Monday':
          day = 'Segunda-feira';
          break;
        case 'Tuesday':
          day = 'Terça-feira';
          break;
        case 'Wednesday':
          day = 'Quarta-feira';
          break;
        case 'Thursday':
          day = 'Quinta-feira';
          break;
        case 'Friday':
          day = 'Sexta-feira';
          break;
        case 'Saturday':
          day = 'Sábado';
          break;
        case 'Sunday':
          day = 'Domingo';
          break;
      }
      return day;
    }

    get beginPeriod() {
      return this.begin_period.slice(0, 5);
    }

    get endPeriod() {
      return this.end_period.slice(0, 5);
    }
}