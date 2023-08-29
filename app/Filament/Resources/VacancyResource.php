<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VacancyResource\Pages;
use App\Filament\Resources\VacancyResource\RelationManagers;
use App\Filament\Resources\VacanyResourcesResource\RelationManagers\QuestionsRelationManager;
use App\Models\Vacancy;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Filament\Forms;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VacancyResource extends Resource
{
    protected static ?string $model = Vacancy::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Heading')
                    ->tabs([
                        Tabs\Tab::make('Vacancy Details')
                            ->schema([
                                Forms\Components\TextInput::make('internal_reference')
                                    ->maxLength(255)
                                    ->label('Internal Reference')
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('job_title')
                                    ->required()
                                    ->maxLength(255)
                                    ->label('Job Title')
                                    ->columnSpanFull(),
                                Forms\Components\Select::make('jobTypes')
                                    ->multiple()
                                    ->relationship('jobTypes', 'name')
                                    ->preload()
                                    ->label('Job Types')
                                    ->columnSpan(1),
                                Forms\Components\Select::make('continents')
                                    ->multiple()
                                    ->relationship('continents', 'name')
                                    ->preload()
                                    ->columnSpan(1),
                                Forms\Components\Select::make('country_id')
                                    ->relationship('country', 'name')
                                    ->preload()
                                    ->label('Country')
                                    ->columnSpan(1),
                                Forms\Components\TextInput::make('location')
                                    ->required()
                                    ->columnSpan(1)
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('postcode')
                                    ->required()
                                    ->label('Postcode/Zipcode')
                                    ->columnSpan(1)
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('display_location')
                                    ->label('Display Location')
                                    ->columnSpan(1)
                                    ->maxLength(255),
                                //belongs to salary range
                                Forms\Components\Section::make('Salary Range')
                                    ->label('Salary Range')
                                    ->relationship('salaryRange', 'code')
                                    ->schema([
                                        Forms\Components\Select::make('code')
                                            ->options([
                                                'USD' => 'USD',
                                                'GBP' => 'GBP',
                                            ])
                                            ->preload(),
                                        Forms\Components\TextInput::make('from')
                                            ->required()
                                            ->prefixIcon('heroicon-o-currency-pound')
                                            ->numeric()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('to')
                                            ->required()
                                            ->prefixIcon('heroicon-o-currency-pound')
                                            ->numeric()
                                            ->maxLength(255),
                                        Forms\Components\Select::make('time_period')
                                            ->label('Time Period')
                                            ->options([
                                                'hour' => 'Per Hour',
                                                'day' => 'Per Day',
                                                'week' => 'Per Week',
                                                'month' => 'Per Month',
                                                'year' => 'Per Year',
                                            ])
                                            ->preload(),
                                    ])->columns(4),
                                Forms\Components\Toggle::make('hide_salary')
                                    ->label('Hide Salary')
                                    ->helperText('Do not display the salary range on the website')
                                    ->columnSpanFull(),
                                Forms\Components\Select::make('sectors')
                                    ->relationship('sectors', 'name')
                                    ->multiple()
                                    ->preload()
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('bonus_benefits')
                                    ->label('Bonus/Benefits')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull()
                            ])->columns(2),
                        Tabs\Tab::make('Vacancy Description')
                            ->schema([
                                Forms\Components\RichEditor::make('description')
                                    ->required()
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('contract_duration')
                                    ->label('Contract Duration')
                                    ->maxLength(255),
                            ])->columns(2),
                        Tabs\Tab::make('Employer')
                            ->schema([
                                Forms\Components\TextInput::make('employer_name')
                                    ->label('Company Name')
                                    ->maxLength(255)
                                    ->columnSpan(1),
                                CuratorPicker::make('employer_logo')
                                    ->label('Logo'),
                            ])->columns(2),
                        Tabs\Tab::make('Application and Contact Information')
                            ->schema([
                                Forms\Components\Select::make('response_method')
                                    ->label('Response Method')
                                    ->options([
                                        'email' => 'Email',
                                        'external' => 'External Website',
                                    ])
                                    ->default('email')
                                    ->live()
                                    ->required(),
                                Forms\Components\TextInput::make('response_action')
                                    ->live()
                                    ->reactive()
                                    ->label('Response Action')
                                    ->label(fn(Get $get) => $get('response_method') === 'external' ? 'External Website URL' : 'Email Address')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('contact_name')
                                    ->label('Contact Name')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('contact_email')
                                    ->label('Contact Email')
                                    ->email()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('contact_telephone')
                                    ->label('Contact Telephone')
                                    ->tel()
                                    ->columnSpanFull()
                                    ->maxLength(255),
                                Forms\Components\Toggle::make('cover_letter')
                                    ->label('Cover Letter')
                                    ->helperText('Require a cover letter to be uploaded')
                                    ->columnSpanFull(),
                            ])->columns(2),
                        Tabs\Tab::make('Administration Settings')
                            ->schema([
                                Forms\Components\Toggle::make('featured')
                                    ->label('Featured')
                                    ->helperText('Feature this vacancy on the website')
                                    ->columnSpan(1),
                                Forms\Components\Toggle::make('suspended')
                                    ->label('Suspended')
                                    ->helperText('Suspend this vacancy on the website')
                                    ->columnSpan(1),
                                Forms\Components\Toggle::make('draft')
                                    ->label('Draft')
                                    ->helperText('Save this vacancy as a draft')
                                    ->columnSpanFull(),
                                Forms\Components\DatePicker::make('posting_start_date')
                                    ->label('Posting Start Date')
                                    ->required(),
                                Forms\Components\DatePicker::make('expiry_date')
                                    ->label('Expiry Date')
                                    ->required(),
                            ])->columns(2),
                    ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('internal_reference')
                    ->label('Internal Reference')
                    ->searchable(),
                Tables\Columns\TextColumn::make('job_title')
                    ->label('Job Title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('employer_name')
                    ->label('Employer')
                    ->searchable(),
                Tables\Columns\IconColumn::make('featured')
                    ->boolean(),
                Tables\Columns\IconColumn::make('suspended')
                    ->boolean(),
                Tables\Columns\IconColumn::make('draft')
                    ->boolean(),
                Tables\Columns\TextColumn::make('posting_start_date')
                    ->label('Start Date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('expiry_date')
                    ->label('Expiry Date')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            QuestionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVacancies::route('/'),
            'create' => Pages\CreateVacancy::route('/create'),
            'view' => Pages\ViewVacancy::route('/{record}'),
            'edit' => Pages\EditVacancy::route('/{record}/edit'),
        ];
    }
}
