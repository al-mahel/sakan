<?php

namespace App\Filament\Resources;

use App\Filament\Forms\Components\MapPicker;
use App\Filament\Resources\UniversityResource\Pages;
use App\Models\University;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class UniversityResource extends Resource
{
    protected static ?string $model = University::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'الجامعات';
    protected static ?string $modelLabel = 'جامعة';
    protected static ?string $pluralModelLabel = 'الجامعات';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('بيانات الجامعة')
                ->schema([

                    Grid::make(2)->schema([

                        Forms\Components\TextInput::make('name')
                            ->label('اسم الجامعة')
                            ->required(),

                        Forms\Components\TextInput::make('city')
                            ->label('المدينة')
                            ->required(),

                    ]),

                    Forms\Components\TextInput::make('address')
                        ->label('العنوان')
                        ->columnSpanFull()
                        ->suffixAction(

                            Action::make('geocode')
                                ->label('تحديد الموقع')
                                ->icon('heroicon-o-map-pin')
                                ->action(function (Forms\Get $get, Forms\Set $set) {

                                    $query = trim(
                                        ($get('address') ?: '') .
                                        ' ' .
                                        ($get('city') ?: '') .
                                        ' مصر'
                                    );

                                    if ($query === 'مصر') {

                                        Notification::make()
                                            ->warning()
                                            ->title('اكتب العنوان أولاً')
                                            ->send();

                                        return;
                                    }

                                    $response = Http::withHeaders([
                                        'User-Agent' => 'Sakan',
                                    ])->get(
                                        'https://nominatim.openstreetmap.org/search',
                                        [
                                            'q' => $query,
                                            'format' => 'json',
                                            'limit' => 1,
                                        ]
                                    );

                                    $data = $response->json();

                                    if (! empty($data)) {

                                        $set('latitude', $data[0]['lat']);
                                        $set('longitude', $data[0]['lon']);

                                        Notification::make()
                                            ->success()
                                            ->title('تم تحديد الموقع')
                                            ->send();

                                    } else {

                                        Notification::make()
                                            ->danger()
                                            ->title('لم يتم العثور على الموقع')
                                            ->send();
                                    }
                                })

                        ),

                    Grid::make(2)->schema([

                        Forms\Components\TextInput::make('latitude')
                            ->numeric()
                            ->readOnly(),

                        Forms\Components\TextInput::make('longitude')
                            ->numeric()
                            ->readOnly(),

                    ]),

                    MapPicker::make('map_picker')
                        ->dehydrated(false)
                        ->columnSpanFull(),

                    Grid::make(2)->schema([

                        Forms\Components\TextInput::make('website')
                            ->label('الموقع الإلكتروني')
                            ->url()
                            ->placeholder('https://example.com'),

                        Forms\Components\Select::make('type')
                            ->label('النوع')
                            ->options([
                                'حكومية' => 'حكومية',
                                'أهلية' => 'أهلية',
                                'خاصة' => 'خاصة',
                            ])
                            ->required(),

                    ]),

                    FileUpload::make('image')
                        ->image()
                        ->directory('universities')
                        ->disk('public')
                        ->visibility('public'),

                    Forms\Components\Textarea::make('description')
                        ->rows(4)
                        ->columnSpanFull(),

                    Grid::make(2)->schema([

                        Forms\Components\TextInput::make('order')
                            ->numeric()
                            ->default(0),

                        Forms\Components\Toggle::make('is_active')
                            ->default(true),

                    ]),

                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table

            ->columns([

                Tables\Columns\ImageColumn::make('image')
                    ->disk('public')
                    ->defaultImageUrl(asset('images/university-placeholder.webp'))
                    ->label('الصورة'),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('city')
                    ->sortable(),

                Tables\Columns\TextColumn::make('type')
                    ->badge(),

                Tables\Columns\TextColumn::make('website')
                    ->url(fn ($record) => $record->website)
                    ->openUrlInNewTab()
                    ->limit(30),

                Tables\Columns\TextColumn::make('properties_count')
                    ->counts('properties')
                    ->label('العقارات'),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),

                Tables\Columns\TextColumn::make('order')
                    ->sortable(),

            ])

            ->defaultSort('order')

            ->reorderable('order')

            ->filters([
                Tables\Filters\TernaryFilter::make('is_active'),
            ])

            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])

            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUniversities::route('/'),
            'create' => Pages\CreateUniversity::route('/create'),
            'edit' => Pages\EditUniversity::route('/{record}/edit'),
        ];
    }
}
