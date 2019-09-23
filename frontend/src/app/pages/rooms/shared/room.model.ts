export class RoomModel
{
  constructor(
    public id?: number,
    public name?: string,
    public description?: string,
    public studio_id?: number,
    public maximum_capacity?: number,
    public color?: string
  ) {}
}
