export class RoomModel
{
  constructor(
    public id?: number,
    public studio_id?: number,
    public name?: string,
    public description?: string,
    public maximum_capacity?: number,
    public color?: string,
    public created_at?: string,
    public updated_at?: string,
    public images?: string
  ) {}
}
