export class CustomerModel {
  constructor(
    public id?: number,
    public firstname?: string,
    public lastname?: string,
    public phone?: string,
    public cpf?: string,
    public city_id?: number,
    public created_at?: string,
    public updated_at?: string,
    public image?: string
  ) {}
  }