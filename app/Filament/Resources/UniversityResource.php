<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UniversityResource\Pages;
use App\Models\University;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UniversityResource extends Resource
{
    protected static ?string $model = University::class;
    protected static ?string $navigationIcon  = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'الجامعات';
    protected static ?string $modelLabel      = 'جامعة';
    protected static ?string $pluralModelLabel = 'الجامعات';
    protected static ?int    $navigationSort  = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('بيانات الجامعة')->schema([
                Grid::make(2)->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('اسم الجامعة')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('city')
                        ->label('المدينة')
                        ->maxLength(255),
                ]),

                Forms\Components\Textarea::make('description')
                    ->label('وصف مختصر')
                    ->rows(3)
                    ->columnSpanFull(),

                Forms\Components\FileUpload::make('image')
                    ->label('صورة الجامعة')
                    ->image()
                    ->disk('public')
                    ->visibility('public')
                    ->directory('universities')
                    ->maxSize(3072)
                    ->columnSpanFull(),

                Grid::make(2)->schema([
                    Forms\Components\TextInput::make('order')
                        ->label('الترتيب')
                        ->numeric()
                        ->default(0),

                Grid::make(2)->schema([
                    Forms\Components\Select::make('type')
                        ->label('نوع الجامعة')
                        ->options([
                            'حكومية' => 'حكومية',
                            'أهلية'  => 'أهلية',
                            'خاصة'   => 'خاصة',
                        ])
                        ->default('حكومية')
                        ->required(),

                    Forms\Components\TextInput::make('website')
                        ->label('موقع الجامعة')
                        ->url()
                        ->placeholder('https://university.edu.eg')
                        ->maxLength(255),
                ]),

                    Forms\Components\Toggle::make('is_active')
                        ->label('نشط')
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
                    ->label('الصورة')
                    ->disk('public')
                    ->height(50)
                    ->width(80)
                    ->defaultImageUrl(asset('images/university-placeholder.webp')),

                Tables\Columns\TextColumn::make('name')
                    ->label('الجامعة')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('city')
                    ->label('المدينة')
                    ->searchable(),

                Tables\Columns\TextColumn::make('properties_count')
                    ->label('العقارات')
                    ->counts('properties')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('نشط')
                    ->boolean(),

                Tables\Columns\TextColumn::make('order')
                    ->label('الترتيب')
                    ->sortable(),

                Tables\Columns\TextColumn::make('type')
                    ->label('النوع')
                    ->badge()
                    ->color(fn(string $state) => match($state) {
                        'حكومية' => 'success',
                        'أهلية'  => 'warning',
                        'خاصة'   => 'primary',
                    }),
            ])
            ->reorderable('order')
            ->defaultSort('order')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('الحالة'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('تعديل'),
                Tables\Actions\DeleteAction::make()->label('حذف'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('حذف المحدد'),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListUniversities::route('/'),
            'create' => Pages\CreateUniversity::route('/create'),
            'edit'   => Pages\EditUniversity::route('/{record}/edit'),
        ];
    }
}
